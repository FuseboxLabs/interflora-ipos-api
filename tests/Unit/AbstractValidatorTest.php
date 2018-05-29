<?php

namespace Interflora\IposApi\Tests\Unit;

use Closure;
use Interflora\IposApi\Entity\Order;
use Interflora\IposApi\Service\OrderValidationService;
use Interflora\IposApi\Constant\OrderType;
use Interflora\IposApi\Validator\Constraints\AbstractOrderValidator;
use Interflora\IposApi\Validator\Constraints\OrderTypeCountries;
use Interflora\IposApi\Validator\Constraints\OrderTypeCountriesValidator;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class AbstractValidatorTest
 */
abstract class AbstractValidatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var OrderValidationService
     */
    protected $orderValidateService;

    /**
     * @var ExecutionContextInterface|MockInterface
     */
    private $context;

    /**
     * @var ConstraintViolationInterface|MockInterface
     */
    private $violation;

    public function setUp()
    {
        $this->orderValidateService = new OrderValidationService();

        $this->violation = Mockery::mock(ConstraintViolationInterface::class);
        $this->violation->shouldReceive('atPath')->andReturnSelf();
        $this->violation->shouldReceive('addViolation')->andReturnSelf();

        $this->context = Mockery::mock(ExecutionContextInterface::class);
    }

    /**
     * @return array
     */
    abstract public function orderDataProvider();

    /**
     * @return AbstractOrderValidator
     */
    abstract protected function getValidator(): AbstractOrderValidator;

    /**
     * @return Constraint
     */
    abstract protected function getConstraint(): Constraint;

    /**
     * Test validate order type.
     *
     * @dataProvider orderDataProvider
     */
    public function testValidate($order, $violation = false)
    {
        $validator               = $this->getValidator();
        $constraint              = $this->getConstraint();

        $this->createContextMock($violation);
        $validator->initialize($this->context);

        $validator->validate($order, $constraint);
    }

    /**
     * @param $violation
     */
    private function createContextMock($violation)
    {
        if ($violation !== false) {
            $this->context->shouldReceive('buildViolation')->andReturn($this->violation)->once()->withArgs([$violation]);
        } else {
            $this->context->shouldNotReceive('buildViolation');
        }
    }
}
